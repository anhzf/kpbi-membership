import { fileURLToPath } from 'node:url';
import eslint from '@eslint/js';
import tseslint from 'typescript-eslint';
import eslintPluginVue from 'eslint-plugin-vue';
import eslintPluginImport from 'eslint-plugin-import';

export default tseslint.config(
  eslint.configs.recommended,
  ...tseslint.configs.recommended,
  {
    languageOptions: {
      ecmaVersion: 2022,
      sourceType: 'module',
      globals: {
        ga: 'readonly', // Google Analytics
        cordova: 'readonly',
        __statics: 'readonly',
        __QUASAR_SSR__: 'readonly',
        __QUASAR_SSR_SERVER__: 'readonly',
        __QUASAR_SSR_CLIENT__: 'readonly',
        __QUASAR_SSR_PWA__: 'readonly',
        process: 'readonly',
        Capacitor: 'readonly',
        chrome: 'readonly'
      },
      parser: tseslint.parser,
      parserOptions: {
        project: ['./tsconfig.json'],
        extraFileExtensions: ['.vue'],
      },
    },
    plugins: {
      '@typescript-eslint': tseslint.plugin,
      vue: eslintPluginVue,
      import: eslintPluginImport,
    },
    rules: {
      'no-param-reassign': 'off',
      'no-void': 'off',
      'no-nested-ternary': 'off',
      'max-classes-per-file': 'off',
      'max-len': ['error', { code: 150, ignoreStrings: true, ignoreTemplateLiterals: true }],

      'no-shadow': 'off',
      '@typescript-eslint/no-shadow': 'error',

      'import/first': 'off',
      'import/named': 'error',
      'import/namespace': 'error',
      'import/default': 'error',
      'import/export': 'error',
      'import/extensions': 'off',
      'import/no-unresolved': 'off',
      'import/no-extraneous-dependencies': 'off',
      'import/prefer-default-export': 'off',
      'no-restricted-exports': 'off',

      'prefer-promise-reject-errors': 'off',

      quotes: ['warn', 'single', { avoidEscape: true }],

      '@typescript-eslint/explicit-function-return-type': 'off',
      '@typescript-eslint/no-var-requires': 'off',
      'no-unused-vars': 'off',
      'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off',
      'no-underscore-dangle': 'off',
      'camelcase': 'off',
      'vue/no-async-in-computed-properties': 'off',
      '@typescript-eslint/consistent-type-imports': [
        'error',
        { prefer: 'type-imports' }
      ],
    },
  },
  {
    files: ['**/*.vue'],
    extends: [
      'plugin:vue/vue3-strongly-recommended',
    ],
    rules: {
      'vue/no-async-in-computed-properties': 'off',
    },
  },
  {
    ignores: [
      'dist/**',
      '.quasar/**',
      'node_modules/**',
    ],
  },
);
