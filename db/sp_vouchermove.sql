USE [ACC]
GO
/****** Object:  StoredProcedure [dbo].[sp_vouchermove]    Script Date: 8/31/2022 4:25:47 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

--DECLARE @current_user varchar(50)
--SET @current_user = SELECT CURRENT_USER 
--exec [sp_moveVoucher] 'O04-2207-120', 'ZIP5-1-1FB', 'nzainpradana'
ALTER  PROCEDURE [dbo].[sp_vouchermove]
	@voucher varchar(50),
	@location_name varchar(50),
	@user varchar(50)
AS
BEGIN
	DECLARE @result varchar(50),
	@location_id varchar(50),
	@item_storage_code varchar(15)


	SET NOCOUNT ON;

	IF EXISTS (SELECT * FROM storage_location WHERE location_name = @location_name)
	BEGIN
		SELECT @location_id = id FROM storage_location WHERE location_name = @location_name

		IF NOT EXISTS (SELECT * FROM dbo.storage_voucher_registered VR WHERE VR.VoucherNo = @voucher)
			BEGIN
				SET @result = 'voucher unregistered'
			END
		ELSE
			BEGIN
				UPDATE storage_voucher_registered
				SET location_id = @location_id, last_update = CURRENT_TIMESTAMP,
				updated_by = @user
				WHERE VoucherNo = @voucher

				IF @@ROWCOUNT > 0
				BEGIN
				SELECT TOP 1 @item_storage_code = item_storage_code FROM storage_voucher_registered WHERE VoucherNo = @voucher

				INSERT INTO storage_voucher_history (item_storage_code, VoucherNo, type, location_id, created_by, created_date)
				VALUES (@item_storage_code, @voucher, 'MOVE', @location_id, @user, CURRENT_TIMESTAMP);

				SET @result = 'success'
				END
				ELSE
				BEGIN
				SET @result = 'failed'
				END
			END
	END
	ELSE
		BEGIN
			SET @result = 'location unregistered'
		END


	SELECT @result as Result
END


