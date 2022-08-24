import { MemberInList } from 'src/types/models';

export interface GetMemberList {
  (): Promise<MemberInList[]>;
}

export interface MemberService {
  list: GetMemberList;
}
