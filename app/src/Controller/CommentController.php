<?php

namespace App\Controller;

use App\Dto\PostListInputFiltersDto;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\Type\CommentType;
use App\Resolver\PostListInputFiltersDtoResolver;
use App\Service\CommentServiceInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/comment')]
class CommentController extends AbstractController
{
    /**
     * Constructor.
     *
     * @param CommentServiceInterface $commentService comment service
     * @param TranslatorInterface  $translator  Translator
     */
    public function __construct(private readonly CommentServiceInterface $commentService, private readonly TranslatorInterface $translator)
    {
    }

    /**
     * Index action.
     *
     * @param PostListInputFiltersDto $filters Input filters
     * @param int                     $page    Page number
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'comment_index',
        methods: 'GET'
    )]
    public function index(#[MapQueryString(resolver: PostListInputFiltersDtoResolver::class)] PostListInputFiltersDto $filters, #[MapQueryParameter] int $page = 1): Response
    {
        /** @var User $user */
        $post = $this->getUser();
        $pagination = $this->commentService->getPaginatedList(
            $page,
            $filters
        );

        return $this->render('comment/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Comment $comment Comment entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'comment_show', requirements: ['id' => '[1-9]\d*'], methods: 'GET')]
    public function show(Comment $comment): Response
    {

        return $this->render(
            'comment/show.html.twig',
            ['comment' => $comment]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route('/create', name: 'comment_create', methods: 'GET|POST')]
    public function create(Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->get('post')->getData();
            $comment->setPost($post);

            $this->commentService->save($comment);

            $this->addFlash('success', $this->translator->trans('message.created_successfully'));

            return $this->redirectToRoute('comment_index');
        }

        return $this->render('comment/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Comment    $comment    Comment entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'comment_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Comment $comment): Response
    {


        $form = $this->createForm(
            CommentType::class,
            $comment,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('comment_edit', ['id' => $comment->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->save($comment);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('comment_index');
        }

        return $this->render(
            'comment/edit.html.twig',
            [
                'form' => $form->createView(),
                'comment' => $comment,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Comment    $comment    comment entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'comment_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Comment $comment): Response
    {
        if ($comment->getAuthor() !== $this->getUser()) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.record_not_found')
            );

            return $this->redirectToRoute('comment_index');
        }

        $form = $this->createForm(
            FormType::class,
            $comment,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('comment_delete', ['id' => $comment->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentService->delete($comment);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('comment_index');
        }

        return $this->render(
            'comment/delete.html.twig',
            [
                'form' => $form->createView(),
                'comment' => $comment,
            ]
        );
    }
}