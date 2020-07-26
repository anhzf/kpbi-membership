function resolveRouteObject(vueInstance, routerObj) {
    return vueInstance.$router.resolve(routerObj).resolved.path
}


export default function (vueInstance, to) {
    let redirectUrl = (typeof to === 'object') ? resolveRouteObject(vueInstance, to) : to

    window.location.assign(redirectUrl)
}