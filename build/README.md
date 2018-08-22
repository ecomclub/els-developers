# Build the documents automatically

1. GET repositories content from
[GitHub API](https://developer.github.com/v3/repos/contents/#get-contents).
2. Parse to JSON documents and save files inside `/docs` directory.

Only Markdown (`.md`) files should be read (but **not only README** files),
save the repository name, full file path and content on JSON documents, such as
[this example](https://github.com/ecomclub/els-developers/blob/master/docs/.sample.json).

## Repositories to read
+ [ecomplus-sdk-js](https://github.com/ecomclub/ecomplus-sdk-js)
+ [ecomplus-store-render](https://github.com/ecomclub/ecomplus-store-render)
+ [ecomplus-search-api-docs](https://github.com/ecomclub/ecomplus-search-api-docs)
+ [ecomplus-api-docs](https://github.com/ecomclub/ecomplus-api-docs)
+ [ecomplus-store-template](https://github.com/ecomclub/ecomplus-store-template)
+ [ecomplus-graphs-api-docs](https://github.com/ecomclub/ecomplus-graphs-api-docs)
+ [storage-api](https://github.com/ecomclub/storage-api)
+ [storefront-app](https://github.com/ecomclub/storefront-app)
+ [ecomplus-passport](https://github.com/ecomclub/ecomplus-passport)
+ [ecomplus-passport-client](https://github.com/ecomclub/ecomplus-passport-client)
+ [webhooks-queue](https://github.com/ecomclub/webhooks-queue)
+ [modules-api](https://github.com/ecomclub/modules-api)
+ [ecomplus-neo4j](https://github.com/ecomclub/ecomplus-neo4j)
