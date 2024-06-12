interface UserLike {
  name: string;
}

export const getUserFallbackImg = (user: UserLike) => `https://placehold.co/100?text=${user.name[0].toUpperCase()}`;
