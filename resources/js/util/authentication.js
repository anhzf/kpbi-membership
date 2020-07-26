import axios from "axios";

const authenticate = (async () => {
    const authentication = (await axios('api/auth')).data
    let isLoggedIn, userId, userEmail, userName

    if ('error' in authentication) {
        isLoggedIn = false
        userId = userEmail = userName = null
    } else {
        isLoggedIn = true;
        ({ id: userId, email: userEmail, name: userName } = authentication)
    }

    return { isLoggedIn, userId, userEmail, userName }
})()

export default authenticate

// export default async () => {
//     const authentication = (await axios('api/auth')).data
//     let isLoggedIn, userId, userEmail, userName

//     if ('error' in authentication) {
//         isLoggedIn = false
//         userId = userEmail = userName = null
//     } else {
//         isLoggedIn = true;
//         ({ id: userId, email: userEmail, name: userName } = authentication)
//     }

//     return { isLoggedIn, userId, userEmail, userName }
// }