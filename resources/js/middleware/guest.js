import authentication from "../util/authentication";

export default async function (to, from, next) {
    const { isLoggedIn: isAuth } = await authentication()
    if (isAuth) next('/')
    else next()
}
