<?php
/*
  1. GET content from GitHub API:
     https://developer.github.com/v3/repos/contents/
  2. Parse to JSON documents and save files inside docs directory
*/
class GitToEls
{
    private $repoToFind = [];
    private $gitPath = 'https://api.github.com/repos/ecomclub/';
    private $data;
    private $dir;

    /**
     * construct 
     *
     * @param array $repos with repositories 
     */
    public function __construct(array $repos)
    {
        if (empty($repos) || !is_array($repos)) {
            throw new Exception("Is required passed a array with repositories names.");
        }

        $this->dir = dirname(__DIR__) . '/docs/';
        $this->repoToFind = $repos;
    }

    /**
     * curl get request  
     *
     * @param [type] $url api endpoint 
     * @return object $response 
     */
    public function request($url)
    {
        $curl = curl_init();
        $reqOptions = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => dirname(__FILE__) . DIRECTORY_SEPARATOR
        ];
        curl_setopt_array($curl, $reqOptions);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * get md files
     *
     * @return array json object $this->data
     */
    public function getMD()
    {
        $count = count($this->repoToFind);
        for ($i=0; $i < $count; $i++) {
            $url = $this->gitPath . $this->repoToFind[$i] .'/readme';
            $response = (object)json_decode($this->request($url));
            $this->data[] = [
                "repo" => $this->repoToFind[$i],
                "path" => $response->name,
                "markdown" => base64_decode(str_replace(["\n"], [""], (string)$response->content))
            ];
        }
        return $this->data;
    }

    /**
     * save array $this->data in a file 
     *
     * @return void
     */
    public function saveMD()
    {
        $count = count($this->data);
        for ($i=0; $i < $count; $i++) { 
            $file = fopen($this->dir . $this->data[$i]['repo'].".json", "w");
            fwrite($file, json_encode($this->data[$i]));
            echo "save {$this->data[$i]['repo']} repository.\n";
            fclose($file);
        }
    }
}

// using
$a = [
    "ecomplus-sdk-js",
    "ecomplus-store-render",
    "ecomplus-search-api-docs",
    "ecomplus-api-docs",
    "ecomplus-store-template",
    "ecomplus-graphs-api-docs",
    "storage-api",
    "storefront-app",
    "ecomplus-passport",
    "ecomplus-passport-client",
    "webhooks-queue",
    "modules-api",
    "ecomplus-neo4j"
];

$g = new GitToEls($a);
$g->getMD();
$g->saveMD();