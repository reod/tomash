<?php
declare(strict_types = 1);

namespace Domain\UseCase\Absence;

use Domain\Exception\AbsenceException;
use Domain\Model\Absence\Absence;
use Domain\UseCase\Absence\TakeDelegation\Command;
use Domain\UseCase\Absence\TakeDelegation\Responder;
use Domain\Storage\AbsenceStorage;

class TakeDelegation
{
    /**
     * @var AbsenceStorage
     */
    private $storage;

    /**
     * TakeDelegation constructor.
     * @param AbsenceStorage $absenceStorage
     */
    public function __construct(AbsenceStorage $absenceStorage)
    {
        $this->storage = $absenceStorage;
    }


    public function execute(Command $command, Responder $responder)
    {
        try {
            $absence = new Absence(
                Absence::ABSENCE_TYPE_DELEGATION,
                $command->getPerson(),
                $command->getDateStart(),
                $command->getDateEnd()
            );
            $this->storage->add($absence);
        } catch (AbsenceException $exception) {
            return $responder->failedToTakeDelegation($exception);
        }

        return $responder->delegationTakenSuccessfully();
    }
}
