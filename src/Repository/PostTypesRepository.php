<?php

namespace App\Repository;

use App\Entity\PostTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PostTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostTypes[]    findAll()
 * @method PostTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostTypes::class);
    }
}
