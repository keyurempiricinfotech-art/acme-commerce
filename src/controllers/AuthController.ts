import { AuthService } from "../services/AuthService";

export class AuthController {
  constructor(private readonly authService: AuthService) {}

  login = async (req: any, res: any) => {
    const result = await this.authService.login(req.body.email);
    res.json(result);
  };
}
