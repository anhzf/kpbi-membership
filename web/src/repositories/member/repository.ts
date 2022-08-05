import type { Member } from 'src/types/models';

export interface MemberRepository {
  getAll(): Promise<Member[]>;
}
