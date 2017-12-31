<?php

namespace SQLC\GenerateData\Model;


use SQLC\SQLC;

class Api
{
    const DATASETS_DIR = '../json/dataSets/';
    const EXPORT_TYPE_PATH =  '../json/exportType.json';

    /** @var string */
    protected $generateDataUrl;

    /**
     * Api constructor.
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct()
    {
        $this->generateDataUrl = SQLC::getServiceLocator()
            ->get('ViewHelperManager')
            ->get('ServerUrl')
        ('/generatedata/api/v1/data');
    }

    /**
     * @param string $tableName
     * @param int    $numRows
     *
     * @return array
     * @throws \InvalidArgumentException
     *
     */
    public function requestData(string $tableName, int $numRows): array
    {
        $dataSetDecoded = $this->getDataSet($tableName);

        $json = $this->buildJsonRequest($numRows, $dataSetDecoded);

        $ch = curl_init($this->generateDataUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = unserialize($response);

        return $data;
    }

    /**
     * @param string $path
     *
     * @return array
     */
    protected function loadJson(string $path): array
    {
        $json = file_get_contents($path);

        if (!$json) {
            throw new \InvalidArgumentException('Invalid JSON file: ' . $path);
        }

        return (array)json_decode($json);
    }

    /**
     * @param string $tableName
     *
     * @return array
     */
    protected function getDataSet(string $tableName): array
    {
        $path = __DIR__ . '/' . self::DATASETS_DIR . strtoupper($tableName) . '.json';

        return $this->loadJson($path);
    }

    /**
     * @param array $dataSetDecoded
     * @param int $numRows
     *
     * @return string
     */
    protected function buildJsonRequest(int $numRows, array $dataSetDecoded): string
    {
        $exportType = $this->loadJson(__DIR__ . '/' . self::EXPORT_TYPE_PATH);

        return json_encode(['numRows' => $numRows] + $dataSetDecoded + $exportType);
    }
}