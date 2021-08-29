import * as functions from 'firebase-functions';
import {auth} from './lib/admin';
import {login, convertCurrentAuthenticatedUser, migrateCurrentAuthenticatedUserProfile} from './lib/legacyMigration';
import type * as fbAdmin from 'firebase-admin';
import type {LoginPayload} from './lib/legacyApi';

export const initAdmin = functions.https.onRequest((req, res) => {
  const superAdminEmail = 'dev@kpbi.or.id';
  const superAdminPass = 'iam the super!';

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

export const convertLegacyAccountThenLogin = functions.https.onCall(async (payload: LoginPayload): Promise<string | null> => {
  await login(payload);

  const user = await convertCurrentAuthenticatedUser(payload.password);

  await migrateCurrentAuthenticatedUserProfile(user);

  return auth.createCustomToken(user.uid);
});
