/* eslint-env node */

/*
 * This file runs in a Node context (it's NOT transpiled by Babel), so use only
 * the ES6 features that are supported by your Node version. https://node.green/
 */

// Configuration for your app
// https://v2.quasar.dev/quasar-cli-vite/quasar-config-js

/* eslint func-names: 0 */
/* eslint global-require: 0 */

import { defineConfig } from '#q-app/wrappers';

export default defineConfig((ctx) => ({
  // eslint has been removed from @quasar/app-vite v2
  // use vite-plugin-checker or other linting tools instead

  // https://v2.quasar.dev/quasar-cli-vite/prefetch-feature
  // preFetch: true,

  // app boot file (/src/boot)
  // --> boot files are part of "main.js"
  // https://v2.quasar.dev/quasar-cli-vite/boot-files
  boot: [
    'axios',
    'auth',
    'simple-plugins',
  ],

  // https://v2.quasar.dev/quasar-cli-vite/quasar-config-js#css
  css: [
    'app.sass',
    '~uno.css',
    '~virtual:unocss-devtools',
  ],

  // https://github.com/quasarframework/quasar/tree/dev/extras
  extras: [
    // 'ionicons-v4',
    // 'mdi-v5',
    // 'fontawesome-v6',
    // 'eva-icons',
    // 'themify',
    // 'line-awesome',
    // 'roboto-font-latin-ext', // this or either 'roboto-font', NEVER both!

    'roboto-font', // optional, you are not bound to it
    'material-icons', // optional, you are not bound to it
  ],

  // Full list of options: https://v2.quasar.dev/quasar-cli-vite/quasar-config-js#build
  build: {
    target: {
      browser: ['es2022', 'edge89', 'firefox89', 'chrome89', 'safari15.4'],
      node: 'node16',
    },

    vueRouterMode: 'history', // available values: 'hash', 'history'
    // vueRouterBase,
    vueDevtools: true,
    // vueOptionsAPI: false,

    // publicPath: '/',
    // analyze: true,
    // env: {},
    // rawDefine: {}
    // ignorePublicFolder: true,
    // minify: false,
    // polyfillModulePreload: true,
    // distDir

    // extendViteConf (viteConf) {},
    // viteVuePluginOptions: {},

    vitePlugins: [
      ['unocss/vite', 'uno.config.ts'],
    ],

    // extendViteConf(viteConf) {
    //   viteConf.plugins.push();
    // }

    typescript: {
      strict: true, // enables strict settings for TypeScript
      vueShim: true, // required when using ESLint with type-checked rules, will generate a shim file for `*.vue` files
    }
  },

  // Full list of options: https://v2.quasar.dev/quasar-cli-vite/quasar-config-js#devServer
  devServer: {
    // https: true
    open: true, // opens browser window automatically
    proxy: {
      '/api': 'http://127.0.0.1:8000',
      '/storage': 'http://127.0.0.1:8000',
    },
  },

  // https://v2.quasar.dev/quasar-cli-vite/quasar-config-js#framework
  framework: {
    config: {
      ripple: {
        early: true,
      },
    },

    // iconSet: 'material-icons', // Quasar icon set
    // lang: 'en-US', // Quasar language pack

    // For special cases outside of where the auto-import strategy can have an impact
    // (like functional components as one of the examples),
    // you can manually specify Quasar components/directives to be available everywhere:
    //
    // components: [],
    // directives: [],

    // Quasar plugins
    plugins: [
      'Dialog', 'Loading', 'Notify',
    ],

    // Auto import - how to detect components in your vue files
    // "kebab": q-carousel q-page
    // "pascal": QCarousel QPage
    // "combined": q-carousel QPage
    autoImportComponentCase: 'kebab',

    // Auto import - which file extensions should be interpreted as referring to Vue SFC?
    autoImportVueExtensions: ['vue'],

    // Auto import - which file extensions should be interpreted as referring to script files?
    autoImportScriptExtensions: ['js', 'jsx', 'ts', 'tsx'],

    // Treeshake Quasar's UI on dev too?
    // Recommended to leave this as false for performance reasons.
    devTreeshaking: false,
  },

  // animations: 'all', // --- includes all animations
  // https://v2.quasar.dev/options/animations
  animations: [],

  // https://v2.quasar.dev/quasar-cli-vite/quasar-config-js#sourcefiles
  sourceFiles: {
    // rootComponent: 'src/App.vue',
    // router: 'src/router/index',
    // store: 'src/store/index',
    // pwaRegisterServiceWorker: 'src-pwa/register-service-worker',
    // pwaServiceWorker: 'src-pwa/custom-service-worker',
    // pwaManifestFile: 'src-pwa/manifest.json',
    // electronMain: 'src-electron/electron-main',
    // electronPreload: 'src-electron/electron-preload',
    // bexManifestFile: 'src-bex/manifest.json',
  },

  // https://v2.quasar.dev/quasar-cli-vite/developing-ssr/configuring-ssr
  ssr: {
    // pwaOfflineHtmlFilename: 'offline.html', // do NOT use index.html as name!
    // will mess up SSR

    // extendSSRWebserverConf (esbuildConf) {},
    // extendPackageJson (json) {},

    pwa: false,

    // manualStoreHydration: true,
    // manualPostHydrationTrigger: true,

    prodPort: 3000, // The default port that the production server should use
    // (gets superseded if process.env.PORT is specified at runtime)

    middlewares: [
      'render', // keep this as last one
    ],

    // pwaExtendGenerateSWOptions: (config) => {},
    // pwaExtendInjectManifestOptions: (config) => {},
  },

  // https://v2.quasar.dev/quasar-cli-vite/developing-pwa/configuring-pwa
  pwa: {
    workboxMode: 'GenerateSW', // or 'InjectManifest'
    injectPwaMetaTags: true,
    swFilename: 'sw.js',
    manifestFilename: 'manifest.json',
    useCredentialsForManifestTag: false,
    // extendGenerateSWOptions (cfg) {}
    // extendInjectManifestOptions (cfg) {},
    // extendManifestJson (json) {}
    // extendPWACustomSWConf (esbuildConf) {}
  },

  // Full list of options: https://v2.quasar.dev/quasar-cli-vite/developing-cordova-apps/configuring-cordova
  cordova: {
    // noIosLegacyBuildFlag: true, // uncomment only if you know what you are doing
  },

  // Full list of options: https://v2.quasar.dev/quasar-cli-vite/developing-capacitor-apps/configuring-capacitor
  capacitor: {
    hideSplashscreen: true,
  },

  // Full list of options: https://v2.quasar.dev/quasar-cli-vite/developing-electron-apps/configuring-electron
  electron: {
    // extendElectronMainConf (esbuildConf)
    // extendElectronPreloadConf (esbuildConf)

    inspectPort: 5858,

    bundler: 'packager', // 'packager' or 'builder'

    packager: {
      // https://github.com/electron-userland/electron-packager/blob/master/docs/api.md#options

      // OS X / Mac App Store
      // appBundleId: '',
      // appCategoryType: '',
      // osxSign: '',
      // protocol: 'myapp://path',

      // Windows only
      // win32metadata: { ... }
    },

    builder: {
      // https://www.electron.build/configuration/configuration

      appId: '@kpbi-membership/web',
    },
  },

  // Full list of options: https://v2.quasar.dev/quasar-cli-vite/developing-browser-extensions/configuring-bex
  bex: {
    extraScripts: [
      // No longer need contentScripts as they are extracted from the manifest file
    ],

    // extendBexScriptsConf (esbuildConf) {}
    // extendBexManifestJson (json) {}
  },
}));
