<?php
namespace App\Library;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormCreator
{

    public function __construct(private readonly FormFactoryInterface $formFactory)
    {
    }

    public function createForm(string $type, array $options = [], array $presetData = []): FormInterface
    {
        $form = $this->formFactory->create($type, null, $options);

        foreach ($presetData as $key => $value) {
            if ($form->has($key)) {
                $form->get($key)->setData($value);
            }
        }

        return $form;
    }

    public function createFormAndHandle(
        Request $request,
        string $type,
        array $options = [],
        array $presetData = []
    ): FormInterface {
        $form = $this->createForm($type, $options, $presetData);
        $form->handleRequest($request);

        return $form;
    }
}
