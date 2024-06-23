<?php
/**
 * Contact controller.
 */

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use App\Service\ContactServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ContactController.
 */
#[Route('/users')]
class ContactController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param ContactServiceInterface $contactService Contact service
     * @param TranslatorInterface     $translator     Translator
     */
    public function __construct(private readonly ContactServiceInterface $contactService, private readonly TranslatorInterface $translator)
    {
    }

    /**
     * Index action.
     *
     * @return Response HTTP response
     */
    #[Route(name: 'user_index', methods: 'GET')]
    public function index(#[MapQueryParameter] int $page = 1): Response
    {
        $pagination = $this->contactService->getPaginatedList($page);

        return $this->render('users/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Contact $contact Contact entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'user_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Contact $contact): Response
    {
        return $this->render('users/show.html.twig', ['users' => $contact]);
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/create',
        name: 'user_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactService->save($contact);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'users/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Contact $contact Contact entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'user_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(
            ContactType::class,
            $contact,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('user_edit', ['id' => $contact->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactService->save($contact);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'users/edit.html.twig',
            [
                'form' => $form->createView(),
                'users' => $contact,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Contact $contact Contact entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'user_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(
            FormType::class,
            $contact,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('user_delete', ['id' => $contact->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactService->delete($contact);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('user_index');
        }

        return $this->render(
            'users/delete.html.twig',
            [
                'form' => $form->createView(),
                'users' => $contact,
            ]
        );
    }
}
