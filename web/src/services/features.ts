import { USER_ROLES, type UserRole } from 'src/types/constants';

type IsRoleAllowed = (role: UserRole) => boolean;

// TODO: Upgrade TypeScript to use `satisfies` keyword.
const FEATURES_UNLOCK = Object.freeze({
  ManageUsers: <IsRoleAllowed>((role) => role === 'admin'),
  VerifyPayment: <IsRoleAllowed>((role) => USER_ROLES.includes(role)),
  ManageInvoices: <IsRoleAllowed>((role) => role === 'admin'),
});

export type Feature = keyof typeof FEATURES_UNLOCK;

export const isFeatureAllowed = (role: UserRole, feature: Feature) => (
  FEATURES_UNLOCK[feature]?.(role) ?? false
);
