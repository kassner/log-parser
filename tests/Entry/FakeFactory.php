<?php

namespace Kassner\LogParser\Tests\Entry;

class FakeFactory implements \Kassner\LogParser\LogEntryFactoryInterface
{
    public function create(array $data): \Kassner\LogParser\LogEntryInterface
    {
        $entry = new Fake();
        $entry->host = $data['host'];

        return $entry;
    }
}
