CREATE OR REPLACE FUNCTION recalc_cart(cart_id TEXT, user_id TEXT)
RETURNS JSONB
LANGUAGE plpgsql
AS $$
DECLARE
  cart_row carts%ROWTYPE;
BEGIN
  SELECT * INTO cart_row
  FROM carts
  WHERE id = cart_id;

  RETURN jsonb_build_object(
    'cart_id', cart_id,
    'user_id', user_id,
    'payload', cart_row.payload,
    'updated_at', cart_row.updated_at
  );
END;
$$;
