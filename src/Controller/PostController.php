<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class PostController extends AbstractController
{
    #[Route('/posts', name: 'post_index')]
    public function index(PostRepository $postRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $queryBuilder = $postRepository->createQueryBuilder('p');
        
        $pagination = $paginator->paginate(
            $queryBuilder, // dotaz nebo pole
            $request->query->getInt('page', 1),
            24
        );
        
        return $this->render('post/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    
    #[Route('/post/{id}', name: 'post_show')]
    public function show(PostRepository $postRepository, int $id): Response
    {
        $post = $postRepository->find($id);
        
        if (!$post) {
            throw $this->createNotFoundException('The post does not exist');
        }
        
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }
}

