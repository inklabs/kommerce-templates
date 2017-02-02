# Zen Kommerce - Foundation Store Theme

Base templates utilizing [Foundation Sites (6.3)](https://github.com/zurb/foundation-sites)

## Installing Dependencies

You can use npm or yarn, both work just fine.

If you havent tried out [yarn](https://github.com/yarnpkg/yarn), it is a 90% drop in replacement for npm that runs much faster. 

See the [repo](https://github.com/yarnpkg/yarn) for install instructions. Or if you're on a mac, `brew install yarn`. If you dont have [brew](http://brew.sh/), you should probably have [brew](https://www.google.com/search?q=beer&tbm=isch).

```bash
# yarn or yarn install
yarn install

# or 
npm install
```

## Building

If you peek in [package.json](store/package.json) you will see a section similar to: 

```json
  "scripts": {
    "prod": "...",
    "dev": "...",
    "watch": "..."
  },
```

Which reveals the scripts:

```bash
# Production - minfied
npm run prod

# Development - not minified and with source maps* 
npm run dev

# Watch - hang and watch for changes in ./scss and ./javascript)
npm run watch 

# *incoming

```
