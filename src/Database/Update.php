<?php

namespace Did\Database;

/**
 * Class Update
 *
 * @uses Update
 *
 * @package Did\Database
 * @author (c) Julien Bernard <hello@julien-bernard.com>
 */
class Update extends AbstractConnection
{
    /**
     * @var string
     */
    private $path;

    /**
     * Update constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        parent::connect();

        $this->path = $path;
    }

    /**
     * @uses run
     *
     * @return string
     */
    public function run(): string
    {
        $files = array_diff(scandir($this->path), ['..', '.']);

        foreach ($files as $file) {
            $fileFullPath = $this->path . DIRECTORY_SEPARATOR . $file;

            if (!is_file($fileFullPath)) {
                continue;
            }

            $extension = pathinfo($file, PATHINFO_EXTENSION);

            if ($extension === 'sql') {
                $content = explode(';', file_get_contents($fileFullPath));

                foreach ($content as $query) {
                    if (empty($query)) {
                        continue;
                    }

                    $this->db->exec($query);
                }
            }
        }

        return 'OK';
    }
}
