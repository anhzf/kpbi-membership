import * as functions from 'firebase-functions';
import * as fbAdmin from 'firebase-admin';
import axios from 'axios';
import type {AxiosRequestConfig} from 'axios';

const admin = (() => {
  const app = fbAdmin.initializeApp();

  return () => app;
})();

export const initAdmin = functions.https.onRequest((req, res) => {
  const superAdminEmail = 'dev@kpbi.or.id';
  const superAdminPass = 'iam the super!';
  const auth = admin().auth();

  auth.getUserByEmail(superAdminEmail)
      .then(() => res.send('admin already created!'))
      .catch(async (err: fbAdmin.FirebaseError) => {
        if (err.code === 'auth/user-not-found') {
          const user = await auth.createUser({
            email: superAdminEmail,
            password: superAdminPass,
            displayName: 'KPBI Dev',
          });

          await auth.setCustomUserClaims(user.uid, {
            admin: true,
          });

          return res.send('Succesfully initialized admin!');
        }

        return res.send(err.toJSON());
      })
      .finally(() => res.end());
});

/* eslint-disable camelcase */
interface LoginPayload {
  name: string;
  password: string;
}

interface ApiLoginResponse {
  success: boolean;
  access_token: string;
  expires_at: string;
  token_type: 'Bearer';
}

type LegacyLoginResponse = string | null;

export const legacyLogin = functions.https.onCall(async (payload: LoginPayload): Promise<LegacyLoginResponse> => {
  /* should use async await syntax!. do post request using axios to https://anggota.kpbi.or.id/api/auth/login with Content-Type json
    with json encoded payload if api call is success it will return ApiLoginResponse,
    grab the access_token and token_type then add token_type keyword before the access_token then
    assign it to the Authorization header for next get request to https://anggota.kpbi.or.id/api/auth/user to retrieve user email.
    if request is success, then check retrieved email if exists using firebase-admin then create custom token,
    otherwise create new user and create custom token. then return the token generated to client */

  const apiUrl = 'https://anggota.kpbi.or.id/api/auth/login';
  const apiHeaders = {
    'Content-Type': 'application/json',
  };

  const apiOptions: AxiosRequestConfig = {
    url: apiUrl,
    method: 'POST',
    headers: apiHeaders,
    data: payload,
  };

  const apiResponse = await axios(apiOptions);

  const apiLoginResponse = apiResponse.data as ApiLoginResponse;

  if (apiLoginResponse.success) {
    const accessToken = apiLoginResponse.access_token;
    const tokenType = apiLoginResponse.token_type;

    const apiOptions2: AxiosRequestConfig = {
      url: 'https://anggota.kpbi.or.id/api/auth/user',
      method: 'GET',
      headers: {
        ...apiHeaders,
        Authorization: `${tokenType} ${accessToken}`,
      },
    };

    const apiResponse2 = await axios(apiOptions2);
    const apiLoginResponse2 = apiResponse2.data;

    const email = apiLoginResponse2.email;
    const auth = admin().auth();

    try {
      const user = await auth.getUserByEmail(email);

      const token = await auth.createCustomToken(user.uid);
      return token;
    } catch (err) {
      if (err.code === 'auth/user-not-found') {
        const userData = {
          email,
          password: payload.password,
          displayName: payload.name,
        };

        const user = await auth.createUser(userData);

        const token = await auth.createCustomToken(user.uid);

        return token;
      }
    }
  }

  return null;
});
