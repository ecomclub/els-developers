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
    private $pagination = 1;
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
            CURLOPT_USERAGENT => dirname(__FILE__) . DIRECTORY_SEPARATOR,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => @$argv[1].':'.@$argv[2]
        ];
        curl_setopt_array($curl, $reqOptions);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * search for all md files on repository
     *
     * @return void
     */
    public function search()
    {
        $url = "https://api.github.com/search/code?q=user:ecomclub+extension:md+language:Markdown&type=Code&page={$this->pagination}&per_page=100";//page=2&per_page=100
        $response = (object)json_decode($this->request($url));
        if (!empty($response->items)) {
            foreach ($response->items as $item) {
                if (in_array($item->repository->name, $this->repoToFind)) {
                    if ($this->isMD($item->name)) {
                        $md = (object)json_decode($this->request($item->url));
                        $this->data[] = [
                            "repo" => $item->repository->name,
                            "path" => $md->path,
                            "markdown" => base64_decode((string)$md->content)
                        ];
                    }
                }
            }
            ++$this->pagination;
            $this->search();
        }
    }

    /**
     * verify if file is a .md
     *
     * @param [type] $file
     * @return boolean
     */
    public function isMD($file)
    {
        return substr($file, -3) === ".md" ? true : false;
    }

    /**
     * save array $this->data in a file
     *
     * @return void
     */
    public function save()
    {
        $count = count($this->data);
        if ($count) {
            for ($i=0; $i < $count; $i++) {
                if (!file_exists($this->dir . $this->data[$i]['repo'])) {
                    mkdir($this->dir . $this->data[$i]['repo'], 0777, true);
                }
                $file = fopen($this->dir . $this->data[$i]['repo'].'/'.str_replace(["/"], ["-"], $this->data[$i]['path']).".json", "w");
                fwrite($file, json_encode($this->data[$i], JSON_PRETTY_PRINT));
                echo "INFO: Save {$this->data[$i]['repo']} repository.\n";
                fclose($file);
            }
        }
    }
}

$repos = ["ecomplus-sdk-js","ecomplus-store-render","ecomplus-search-api-docs","ecomplus-api-docs","ecomplus-store-template","ecomplus-graphs-api-docs","storage-api","storefront-app","ecomplus-passport","ecomplus-passport-client","webhooks-queue","modules-api","ecomplus-neo4j"];
$git = new GitToEls($repos);
$git->search();
$git->save(); 
