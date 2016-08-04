# Kommerce Base Foundation Theme

## Install Requirements
Node (using [nvm](https://github.com/creationix/nvm) preferably, I am running 5.11.1)

## Installing


## Building
If you peek in [package.json](./package.json) you will see a section similar to: 

```json
  "scripts": {
    "prod": "node build/build.js",
    "dev": "node build/dev.js",
    "watch": "webpack --watch --config ./build/webpack.dev.conf.js"
  },
```

This defines three scripts you can run with the following commands:

```bash
// runs a production build once, production build includes
// manglejs/mini, autoprefixing/mini sass, 
npm run prod

// runs sass and js build for dev once, dev build includes:
// inline sourcemaps, no autoprefixing, no mangle
 npm run dev
 
 // runs a watcher for both sass and js, this is basically dev + hang and watch
 npm run watch
 
```