import { GUARD_TYPES } from 'src/constants';

export type GuardType = typeof GUARD_TYPES[number];

export type LooseDictionary = Record<string, unknown>;
