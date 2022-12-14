USE [ACC]
GO
/****** Object:  StoredProcedure [dbo].[sp_voucherregister]    Script Date: 8/31/2022 4:26:16 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

--exec sp_voucherregister 'O04-2208-013','ZIP1-OFC-L01-R01-B01-BT01','nzainpradana','VCR'
ALTER  PROCEDURE [dbo].[sp_voucherregister]
	@voucher varchar(50),
	@location_name varchar(50),
	@user varchar(50),
	@doc_type VARCHAR(3)
AS
BEGIN
	DECLARE @result varchar(50),  @counter int = 1,  @PaymentTo varchar(255),
	@Particulars varchar(255), @BankName varchar(255), @Currency char(3),
	@location_id varchar(50), @lastcount int


	SET NOCOUNT ON;

	-- Check Apakah Location Sudah Terdaftar
	IF EXISTS (SELECT * FROM storage_location WHERE location_name = @location_name)
	BEGIN
		-- Cari ID Lokasi
		SELECT @location_id = id FROM storage_location WHERE location_name = @location_name

		IF NOT EXISTS (SELECT * FROM dbo.storage_voucher_registered VR WHERE VR.VoucherNo = @voucher)
			BEGIN
				-- Ambil data dari Table BankBooks
				SELECT @PaymentTo = PaymentTo, @Particulars = Particulars, @BankName = BankName, @Currency = Currency FROM RPA_BankBook WHERE VouncherNo = @voucher;

				-- Get Item Storage Code
				
				DECLARE @last_code VARCHAR(30)

				IF EXISTS(SELECT TOP 1 *  
				FROM storage_voucher_registered 
				WHERE item_storage_code LIKE CONCAT(@doc_type, YEAR(GETDATE()), FORMAT(MONTH(GETDATE()), '00'), '-', '%') 
				ORDER BY item_storage_code DESC)
				BEGIN

					SELECT TOP 1 @last_code =  CONCAT('VCR',YEAR(GETDATE()), FORMAT(MONTH(GETDATE()), '00'), '-', FORMAT(CONVERT(INT,RIGHT(item_storage_code, 4)) + 1, '0000'))
					FROM storage_voucher_registered 
					WHERE item_storage_code LIKE CONCAT('VCR', YEAR(GETDATE()), FORMAT(MONTH(GETDATE()), '00'), '-', '%') 
					ORDER BY item_storage_code DESC
				END
				ELSE 
				BEGIN
					SET @last_code = CONCAT(@doc_type,YEAR(GETDATE()), FORMAT(MONTH(GETDATE()), '00'), '-', '0001')
				END
				




				INSERT INTO dbo.storage_voucher_registered (item_storage_code, VoucherNo, PaymentTo, Particulars, BankName, Currency, location_id, status, created_by, created_date) 
				VALUES (@last_code, @voucher, @PaymentTo, @Particulars, @BankName, @Currency, @location_id, 1, @user, CURRENT_TIMESTAMP);

				IF @@ROWCOUNT > 0
				BEGIN
				INSERT INTO storage_voucher_history (item_storage_code, VoucherNo, type, location_id, created_by, created_date)
				VALUES (@last_code, @voucher, 'IN', @location_id, @user, CURRENT_TIMESTAMP)
				SET @result = 'success'
				END
				ELSE
				BEGIN
				SET @result = 'failed'
				END
			END
		ELSE
			BEGIN
				UPDATE storage_voucher_registered
				SET location_id = @location_id, status = 1, last_update = CURRENT_TIMESTAMP,
				updated_by = @user
				WHERE VoucherNo = @voucher

				IF @@ROWCOUNT > 0
				BEGIN
				INSERT INTO storage_voucher_history (VoucherNo, type, location_id, created_by, created_date)
				VALUES (@voucher, 'IN', @location_id, @user, CURRENT_TIMESTAMP)
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


	SELECT @result as Result, @last_code  as item_code_storage
END

