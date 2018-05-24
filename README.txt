This project aims to add subscription support to the GraphQL module.

Since it is under active development, there are going to be frequent updates as well as patches to the GraphQL module that you will need to apply. This currently works with the GraphQL module Beta7 and Beta8 releases. This module depends on graphql, graphql_core, and graphql_mutation. Patches are in the "patches" folder and need to be applied before installing the module.

Download to your modules directory or modules/custom directory and apply the patches in the "patches" folder. Make sure you have GraphQL beta7 or beta8.

Once the patches are applied and the dependencies are met, you can then enable the module. This module comes with a package.json file which will also need to be run. In your command line, navigate to this module directory and run either, npm install, or yarn.

Since this requires a nodejs graphql server to be running, this module provides that. After running npm install or yarn, just run npm start, or yarn start. This needs to be running at all times to be able to handle subscriptions so you may want to create a forever script or use something like PM2.

One of the current limitations is that it sends an arbitrary object type back to the client. As in it doesn't conform to a full type such as a query or mutation would (EntityCrudOutput for example). However, it does send back exactly what fields were requested in the mutation.
