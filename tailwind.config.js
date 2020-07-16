const plugin = require('tailwindcss/plugin')

module.exports = {
  purge: [
    // './resources/**/*.html',
    // './resources/**/*.blade.php',
  ],
  theme: {
    extend: {},
  },
  variants: {
    backgroundColor: ['responsive', 'hover', 'focus', 'active', 'group-hover'],
    display: ['responsive', 'hover', 'focus', 'group-hover'],
    borderRadius: ['responsive', 'hover', 'focus', 'first', 'last'],
  },
  plugins: [
    plugin(({addUtilities}) => {

      addUtilities({
        '.grid-center': {
          'place-items' : 'center',
        },
      })

    })
  ],
}
