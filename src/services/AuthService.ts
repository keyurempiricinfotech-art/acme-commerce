import { UserRepository } from "../auth/UserRepository";

export class AuthService {
  constructor(private readonly userRepository: UserRepository) {}

  async login(email: string) {
    const user = await this.userRepository.findUserByEmail(email);
    return { ok: Boolean(user), user };
  }
}
