import * as functions from "firebase-functions";
import * as fbAdmin from "firebase-admin";

const admin = (() => {
  const app = fbAdmin.initializeApp();

  return () => app;
})();

// // Start writing Firebase Functions
// // https://firebase.google.com/docs/functions/typescript
//

export const initAdmin = functions.https.onRequest((req, res) => {
  const superAdminEmail = "dev@kpbi.or.id";
  const superAdminPass = "iam the super!";
  const auth = admin().auth();

  auth.getUserByEmail(superAdminEmail)
      .then(() => res.send("admin already created!"))
      .catch(async (err: fbAdmin.FirebaseError) => {
        if (err.code === "auth/user-not-found") {
          const user = await auth.createUser({
            email: superAdminEmail,
            password: superAdminPass,
            displayName: "KPBI Dev",
          });

          await auth.setCustomUserClaims(user.uid, {
            admin: true,
          });

          return res.send("Succesfully initialized admin!");
        }

        return res.send(err.toJSON());
      })
      .finally(() => res.end());
});
