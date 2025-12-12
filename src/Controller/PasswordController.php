<?php

namespace App\Controller;

use App\Dto\GeneratePasswordDTO;
use App\Form\GeneratePasswordType;
use App\Library\FormCreator;
use App\Service\PasswordGenerateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/password')]
final class PasswordController extends AbstractController
{
    #[Route('/generate', name: 'generate_password', methods: ['GET','POST'])]
    public function generate(
        Request $request,
        FormCreator $formCreator,
        PasswordGenerateService $passwordGenerateService
    ): Response {
        $form = $formCreator->createFormAndHandle($request, GeneratePasswordType::class);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $generatePasswordDTO = new GeneratePasswordDTO(
                passwordLength: $formData['passwordLength'],
                numbers: $formData['numbers'],
                lowercase: $formData['lowercase'],
                uppercase: $formData['uppercase'],
            );

            $password = $passwordGenerateService->generatePassword($generatePasswordDTO);
        }

        return $this->render('base.html.twig', [
            'form' => $form->createView(),
            'password' => $password ?? null,
        ]);
    }
}
