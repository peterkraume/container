<?php
namespace B13\Container\Tests\Functional\Datahandler\Localization\FreeMode;

use B13\Container\Tests\Functional\Datahandler\DatahandlerTest;

class CopyElementClipboardOtherPageTest extends DatahandlerTest
{

    /**
     * @throws \Doctrine\DBAL\DBALException
     * @throws \TYPO3\TestingFramework\Core\Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Fixtures/sys_language.xml');
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Fixtures/pages.xml');
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Fixtures/tt_content_translations_free_mode.xml');
        $this->importDataSet(ORIGINAL_ROOT . 'typo3conf/ext/container/Tests/Functional/Fixtures/tt_content_translations_free_mode_other_page.xml');
    }

    /**
     * @test
     */
    public function copyChildElementOutsideContainerAtTop(): void
    {
        $cmdmap = [
            'tt_content' => [
                52 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => 3,
                        'update' => [
                            'colPos' => 0,
                            'sys_language_uid' => 1

                        ]
                    ]
                ]
            ]
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('t3_origuid', 52);
        $this->assertSame(0, (int)$row['tx_container_parent']);
        $this->assertSame(0, (int)$row['colPos']);
        $this->assertSame(3, (int)$row['pid']);
        $this->assertSame(1, (int)$row['sys_language_uid']);
    }


    /**
     * @test
     */
    public function copyChildElementOutsideContainerAfterElement(): void
    {
        $cmdmap = [
            'tt_content' => [
                52 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => -64,
                        'update' => [
                            'colPos' => 0,
                            'sys_language_uid' => 1

                        ]
                    ]
                ]
            ]
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('t3_origuid', 52);
        $this->assertSame(0, (int)$row['tx_container_parent']);
        $this->assertSame(0, (int)$row['colPos']);
        $this->assertSame(3, (int)$row['pid']);
        $this->assertSame(1, (int)$row['sys_language_uid']);
    }

    /**
     * @test
     */
    public function copyChildElementToOtherColumnTop(): void
    {
        $cmdmap = [
            'tt_content' => [
                52 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => 3,
                        'update' => [
                            'colPos' => '61-201',
                            'sys_language_uid' => 1

                        ]
                    ]
                ]
            ]
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('t3_origuid', 52);
        $this->assertSame(61, (int)$row['tx_container_parent']);
        $this->assertSame(201, (int)$row['colPos']);
        $this->assertSame(3, (int)$row['pid']);
        $this->assertSame(1, (int)$row['sys_language_uid']);
    }

    /**
     * @test
     */
    public function copyChildElementToOtherColumnAfterElement(): void
    {
        $cmdmap = [
            'tt_content' => [
                52 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => -63,
                        'update' => [
                            'colPos' => '61-201',
                            'sys_language_uid' => 1

                        ]
                    ]
                ]
            ]
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('t3_origuid', 52);
        $this->assertSame(61, (int)$row['tx_container_parent']);
        $this->assertSame(201, (int)$row['colPos']);
        $this->assertSame(3, (int)$row['pid']);
        $this->assertSame(1, (int)$row['sys_language_uid']);
    }

    /**
     * @test
     */
    public function copyElementIntoContainerAtTop(): void
    {
        $cmdmap = [
            'tt_content' => [
                54 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => 3,
                        'update' => [
                            'colPos' => '61-201',
                            'sys_language_uid' => 1

                        ]
                    ]
                ]
            ]
        ];

        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('t3_origuid', 54);
        $this->assertSame(61, (int)$row['tx_container_parent']);
        $this->assertSame(201, (int)$row['colPos']);
        $this->assertSame(3, (int)$row['pid']);
        $this->assertSame(1, (int)$row['sys_language_uid']);
    }

    /**
     * @test
     */
    public function copyElementIntoContainerAfterElement(): void
    {
        $cmdmap = [
            'tt_content' => [
                54 => [
                    'copy' => [
                        'action' => 'paste',
                        'target' => -63,
                        'update' => [
                            'colPos' => '61-201',
                            'sys_language_uid' => 1

                        ]
                    ]
                ]
            ]
        ];
        $this->dataHandler->start([], $cmdmap, $this->backendUser);
        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();
        $row = $this->fetchOneRecord('t3_origuid', 54);
        $this->assertSame(61, (int)$row['tx_container_parent']);
        $this->assertSame(201, (int)$row['colPos']);
        $this->assertSame(3, (int)$row['pid']);
        $this->assertSame(1, (int)$row['sys_language_uid']);
    }
}