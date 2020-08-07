const
    required = v => !!v || 'Wajib diisi',
    email = v => /.+@.+\..+/.test(v) || 'E-mail tidak valid'


export {
    required, email
}