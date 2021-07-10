<?php

namespace App\Form;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\WarmedClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    private RouterInterface $router;
    private UserRepository $userRepository ;

    /**
     * UserType constructor.
     * @param RouterInterface $router
     * @param UserRepository $userRepository
     */
    public function __construct(RouterInterface $router, UserRepository $userRepository)
    {
        $this->router = $router;
        $this->userRepository = $userRepository;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fileConstraints=[
            new File(array(
                'maxSize' => '10024k',
                'mimeTypes' => array(
                    'application/pdf',
                    'application/x-pdf',
                ),
                'mimeTypesMessage' => 'Please upload a valid PDF document',
            ))
        ];
        $builder ->add('file', \Symfony\Component\Form\Extension\Core\Type\FileType::class, array('label' => 'Fichier','constraints'=>$fileConstraints));

    }

    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $attr = $view->vars['attr'];
        $id = isset($attr['id']) ? $attr['id'].' ' : '';
        $id .= 'uploadForm';

        $attr['id'] = $id;
        //$attr['data-autocomplete-url'] = $this->router->generate('app_login_autocomplete');
        $view->vars['attr'] = $attr;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'Hmm, user not found!',
            'finder_callback' => function(UserRepository $userRepository, string $email) {
                return $userRepository->findOneBy(['email' => $email]);
            },
        ]);
    }
}
