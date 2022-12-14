USE [ACC]
GO
/****** Object:  StoredProcedure [dbo].[sp_voucherreturn]    Script Date: 8/31/2022 4:26:35 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

--DECLARE @current_user varchar(50)
--SET @current_user = SELECT CURRENT_USER 
--exec [sp_registerVoucher] 'O04-2207-010', 'ZIP5-1-1FB', 'nzainpradana'
ALTER  PROCEDURE [dbo].[sp_voucherreturn]
	@voucher varchar(50),
	@user varchar(50)
AS
BEGIN

DECLARE @location_id int, @result VARCHAR(50), @item_storage_code VARCHAR(15);

	SET NOCOUNT ON;

	SELECT @location_id = location_id FROM storage_voucher_registered WHERE VoucherNo = @voucher;

		
				UPDATE storage_voucher_registered
				SET status = 1, last_update = CURRENT_TIMESTAMP,
				updated_by = @user, out_by = NULL, out_date = NULL
				WHERE VoucherNo = @voucher

				IF @@ROWCOUNT > 0
				BEGIN

				SELECT TOP 1 @item_storage_code = item_storage_code FROM storage_voucher_registered WHERE VoucherNo = @voucher

				INSERT INTO storage_voucher_history (item_storage_code, VoucherNo, type, location_id, created_by, created_date)
				VALUES (@item_storage_code, @voucher, 'RETURN', @location_id, @user, CURRENT_TIMESTAMP);

				DELETE FROM storage_voucher_disposal WHERE VoucherNo = @voucher;

				SET @result = 'success'
				END
				ELSE
				BEGIN
				SET @result = 'failed'
				END

	SELECT @result as Result
END


