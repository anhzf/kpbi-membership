export default async () => {
  try {
    const {data: authentication} = await window.axios('api/auth/user')
    return {
      isLoggedIn: true,
      ...authentication
    }
  } catch (error) {
    return {
      isLoggedIn: false,
      message: error.message,
      response: {...error.response},
      request: {...error.request},
      config: {...error.config},
    }
  }
}
