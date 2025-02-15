/**
 * `auth` let you access whenever you authenticated,
 * `guest` prevent you access if you authenticated,
 * `default` let you freely access.
 */
export const GUARD_TYPES = ['auth', 'guest', 'default'] as const;

/**
 * Old membership fee for 1 year.
 */
export const PAST_MEMBERSHIP_FEE = 300_000;

export const MEMBERSHIP_FEE = 500_000;
