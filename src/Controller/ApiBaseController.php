<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;

abstract class ApiBaseController extends Controller
{
    /**
     * Returns a form.
     *
     * @see createNamed()
     *
     * @param string|FormTypeInterface $type    The type of the form
     * @param mixed                    $data    The initial data
     * @param array                    $options The options
     *
     * @return FormInterface The form
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException if any given option is not
     *                                                                              applicable to the given type
     */
    protected function createAPIForm(
        $type = 'Symfony\Component\Form\Extension\Core\Type\FormType',
        $data = null,
        array $options = array()
    ) {
        if (empty($options)) {
            $options = [];
        }
        $options['csrf_protection'] = false;
        $options['allow_extra_fields'] = true;

        return $this->get('form.factory')->createNamed(null, $type, $data, $options);
    }

    /**
     * get all the errors as an array
     *
     * @param FormInterface $form
     *
     * @return array
     */
    protected function getErrorsFromForm(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = (count($childErrors) == 1) ? implode(' ',
                        $childErrors) : $childErrors;
                }
            }
        }

        return $errors;
    }

}
