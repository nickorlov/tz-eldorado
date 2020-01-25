<?php

namespace App\Repository;

use App\Entity\Song;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Song|null find($id, $lockMode = null, $lockVersion = null)
 * @method Song|null findOneBy(array $criteria, array $orderBy = null)
 * @method Song[]    findAll()
 * @method Song[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SongRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Song::class);
    }

    public function findSongs($params): array
    {
        $qb = $this->createQueryBuilder('s');

        if (isset($params['limit'])) {
            $qb->setMaxResults($params['limit']);
        }
        if (isset($params['order'])) {
            $qb->orderBy('s.name', $params['order']);
        }

        $query = $qb->getQuery();

        return $query->execute();
    }
}
