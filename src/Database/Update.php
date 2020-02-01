<?php

namespace Did\Database;

/**
 * Class Update
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
     * @param string $path
     */
    public function __construct($path)
    {
        parent::connect();

        $this->path = $path;
    }

    public function run()
    {
        $files = array_diff(scandir($this->path), ['..', '.']);

        foreach ($files as $file) {
            $fileFullPath = $this->path . DIRECTORY_SEPARATOR . $file;

            if (!is_file($fileFullPath)) {
                continue;
            }

            $extension = pathinfo($file, PATHINFO_EXTENSION);

            if ($extension === 'php') {

            } elseif ($extension === 'sql') {
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