# els-developers
JSON documents for the Elasticsearch index to E-Com Plus Developers Hub

All documents must be inside `/docs` folder,
it will be synchronized with Elasticsearch cluster by REST API.

# Build
Run the PHP script `/build/main.php` to build the documents automatically.

:page_facing_up: [README](https://github.com/ecomclub/els-developers/tree/master/build)

# Technology stack
+ [Elasticsearch](https://www.elastic.co/products/elasticsearch) 6.3
+ [PHP](http://php.net/) 7.0.26

# Reference
+ [ELS documentation](https://www.elastic.co/guide/en/elasticsearch/reference/current/index.html)
+ [ELS docs API](https://www.elastic.co/guide/en/elasticsearch/reference/current/docs.html)
+ [GitHub Repos REST API v3](https://developer.github.com/v3/repos/contents/#get-contents)

# Setting up
First of all, clone the repository, and
[set up GitHub push with SSH keys](https://gist.github.com/developius/c81f021eb5c5916013dc).

```bash
sudo git clone https://github.com/ecomclub/els-developers.git
cd els-developers
```

Then build the docs, commit and push again to GitHub.

```bash
php -f build/main.php
git add docs/*
git commit -m "build docs"
git push
```
