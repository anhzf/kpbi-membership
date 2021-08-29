/* eslint-disable camelcase */
import {auth} from './admin';
import {collections, factories} from './firestoreCollections';
import * as legacy from './legacyApi';
import {jsonDateToAdminTimestamp} from './utils';
import type {auth as fbAuth} from 'firebase-admin';
import type {Member} from '../../../common/schema';
import type {LegacyProfile} from '../../../common/legacy';
import type {LegacyUser, NodeSchemeOf} from './types';

let currentUser: LegacyUser | null;
let authExpiration: Date;

const isLoginExpired = () => authExpiration >= new Date;

export const login = async (payload: legacy.LoginPayload): Promise<void> => {
  const {data} = await legacy.login(payload);

  if (data.success) {
    authExpiration = new Date(data.expires_at);
    legacy.api.defaults.headers.Authorization;
    legacy.setAuthorization(data.token_type, data.access_token);
  } else {
    throw new Error('Oops! Something error!');
  }
};

export const getCurrentAuthenticatedUser = async () => {
  if (!currentUser || isLoginExpired()) {
    const {data} = await legacy.getAuthenticatedUser();

    currentUser = data;
  }

  return currentUser;
};

export const convertCurrentAuthenticatedUser = async (password = 'default_password') => {
  const legacyUser = await getCurrentAuthenticatedUser();

  if (legacyUser) {
    return auth.getUserByEmail(legacyUser.email)
        .catch(async (err) => {
          if (err.code === 'auth/user-not-found') {
            const user = await auth.createUser({
              email: legacyUser.email,
              password,
              displayName: legacyUser.name,
            });

            await onLegacyAccountConversion(legacyUser.id, user.uid);

            return user;
          }

          throw err;
        });
  } else throw new Error('Unauthenticated!');
};

export const getCurrentAuthenticatedUserProfile = legacy.getAuthenticatedUserProfile;

export const migrateCurrentAuthenticatedUserProfile = async (user: fbAuth.UserRecord) => {
  const {data} = await getCurrentAuthenticatedUserProfile();
  const docRef = collections.Members.doc(user.uid);

  return docRef.set({
    ...legacyProfileConverter(data),
    ...factories.attrs.create(),
  });
};

export const onLegacyAccountConversion = (oldUserId: number, newUserId: string) => {
  return collections.LegacyAccountConversions.add({
    newUserId,
    oldUserId,
    ...factories.attrs.create(),
  });
};

export const legacyProfileConverter = (data: LegacyProfile): Member => ({
  akreditasi: {
    perguruanTinggi: data.akreditasi_pt ?? 'Belum Terakreditasi',
    prodi: {
      value: data.akreditasi_prodi.akreditasi ?? 'Belum Terakreditasi',
      tanggal: jsonDateToAdminTimestamp(data.akreditasi_prodi.tanggal),
      internasional: data.akreditasi_prodi.internasional ?? '',
    },
  },
  emailProdi: data.email_prodi,
  fakultas: data.fakultas ?? '',
  jenjang: data.jenjang,
  jurusan: data.jurusan ?? '',
  kaprodi: {
    email: data.kaprodi.email,
    nama: data.kaprodi.nama ?? '',
    noHp: data.kaprodi.no ?? '',
    periode: {
      mulai: jsonDateToAdminTimestamp(data.kaprodi.periode.mulai),
      purna: jsonDateToAdminTimestamp(data.kaprodi.periode.purna),
    },
  },
  namaProdi: data.nama_prodi,
  noHpProdi: data.no_telp_prodi ?? '',
  perguruanTinggi: {
    alamat: {
      alamat: data.alamat_kampus.alamat ?? '',
      kota: data.alamat_kampus.kota ?? '',
      provinsi: data.alamat_kampus.provinsi ?? '',
    },
    lengkap: data.pt.lengkap,
    singkatan: data.pt.singkat,
  },
  status: data.status,
  webProdi: data.web_prodi ?? '',
} as NodeSchemeOf<Member>);
