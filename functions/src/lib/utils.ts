import {firestore} from 'firebase-admin';

export const jsonDateToAdminTimestamp = (input: string) => firestore.Timestamp.fromDate(new Date(input));
