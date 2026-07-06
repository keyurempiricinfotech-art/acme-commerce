import { CheckoutService } from "../services/CheckoutService";

export class PaymentController {
  constructor(private readonly checkoutService: CheckoutService) {}

  list = async (req: any, res: any) => {
    const result = await this.checkoutService.paymentMethods(req.body.userId);
    res.json(result);
  };
}
