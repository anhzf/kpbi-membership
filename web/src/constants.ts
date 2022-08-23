/**
 * `auth` let you access whenever you authenticated,
 * `guest` prevent you access if you authenticated,
 * `default` let you freely access.
 */
export const GUARD_TYPES = ['auth', 'guest', 'default'] as const;
