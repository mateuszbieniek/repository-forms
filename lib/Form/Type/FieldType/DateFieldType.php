<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\RepositoryForms\Form\Type\FieldType;

use EzSystems\RepositoryForms\FieldType\DataTransformer\DateValueTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Form Type representing ezdate field type.
 */
class DateFieldType extends AbstractType
{
    /** @var \Symfony\Component\HttpFoundation\RequestStack */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix()
    {
        return 'ezplatform_fieldtype_ezdate';
    }

    public function getParent()
    {
        return IntegerType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new DateValueTransformer());
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $request = $this->requestStack->getCurrentRequest();
        $isEditView =
            $request->attributes->get('_route') === 'ez_content_draft_edit' ||
            $request->attributes->get('_route') === 'ezplatform.content.translate';

        $view->vars['attr']['data-action-type'] = $isEditView ? 'edit' : 'create';
        $view->vars['attr']['class'] = 'ez-data-source__input';
        $view->vars['attr']['hidden'] = 'hidden';
    }
}
