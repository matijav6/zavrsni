<?php

namespace App\Repository;

use App\Entity\PostsLikesDislikes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PostsLikesDislikes|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostsLikesDislikes|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostsLikesDislikes[]    findAll()
 * @method PostsLikesDislikes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostsLikesDislikesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostsLikesDislikes::class);
    }
}
