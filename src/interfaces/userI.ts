export interface UserI {
  id?: number;
  email: string;
  is_admin: boolean;
  inscriptionDate: string | Date;
}

export interface UserAuthI extends Pick<UserI, "email"> {
  password: string;
  is_admin?: boolean;
}