<?php

namespace App\Repository;

use App\Entity\Library;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 * @extends ServiceEntityRepository<Library>
 */
class LibraryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Library::class);
    }

    /**
     * Returns the id of books matching the attribute provided.
     *
     * @param mixed $srch the string to search for
     *
     * @return array<string, mixed> the resulting data from the table
     */
    public function getBookIdFromAttribute(mixed $srch): array
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql =
        "
            SELECT id FROM library
            WHERE
                isbn = :srch
                OR title = :srch
                OR author = :srch
                OR img_name = :srch
        ";
        $response = $conn->executeQuery($sql, ["srch" => $srch]);
        $result = $response->fetchAllAssociative();
        return $result[0];
    }

    //    /**
    //     * @return Library[] Returns an array of Library objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Library
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
