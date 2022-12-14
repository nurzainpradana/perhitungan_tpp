USE [ACC]
GO
/****** Object:  StoredProcedure [dbo].[sp_sendemailvoucherout]    Script Date: 8/31/2022 4:26:52 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
-- EXEC [dbo].[sp_sendemailvoucherout]
ALTER PROCEDURE [dbo].[sp_sendemailvoucherout]
AS
BEGIN

	DECLARE @employee_name VARCHAR(255), @user VARCHAR(50), @mail_to VARCHAR(255), @subject VARCHAR(50), 
	@content VARCHAR(MAX), @content_detail VARCHAR(MAX), @voucherNo VARCHAR(50), @out_date VARCHAR(50),
	@duration VARCHAR, @count INT;

	DECLARE C_employee_email CURSOR FOR

	SELECT DISTINCT (SELECT TOP 1 employee_name FROM ZipcoAdm.dbo.V_user WHERE ZipcoAdm.dbo.V_user.user_id = VR.out_by) employee_name,
	(SELECT TOP 1 email FROM ZipcoAdm.dbo.MT_User WHERE ZipcoAdm.dbo.MT_User.user_id = VR.out_by) email, VR.out_by
	FROM storage_voucher_registered VR WHERE VR.out_by IS NOT NULL
	AND DATEDIFF(day, VR.out_date, CURRENT_TIMESTAMP) > 14

	OPEN C_employee_email
	FETCH NEXT FROM C_employee_email
	INTO @employee_name, @mail_to, @user

		WHILE @@FETCH_STATUS = 0
		BEGIN

			--Load Detail Voucher Out By Employee
			DECLARE C_employee_voucher CURSOR FOR
			SELECT VR1.VoucherNo, (CASE WHEN VR1.out_date IS NULL THEN NULL ELSE CAST(FORMAT(VR1.out_date, 'dd MMMM yyyy') AS VARCHAR(50)) END) date, DATEDIFF(day, VR1.out_date, CURRENT_TIMESTAMP) as duration --Indonesian
			FROM storage_voucher_registered VR1
			WHERE out_date IS NOT NULL AND VR1.out_by = @user 
			ORDER BY duration DESC
			OPEN C_employee_voucher
			FETCH NEXT FROM C_employee_voucher
			INTO @voucherNo, @out_date, @duration

			SET @content_detail = '<table border="1" style="border-collapse: collapse;" width="100%">';

			SET @content_detail += '<tr><td><b>Voucher No.</b></td><td><b>Out Date</b></td><td><b>Duration</b></td></tr>';
			
			SET @count = 0

			WHILE @@FETCH_STATUS = 0
				BEGIN

				
			

				SET @content_detail += '<tr><td>'+@voucherNo+'</td><td>'+@out_date+'</td><td>'+@duration+' Days</td></tr>';

				FETCH NEXT FROM C_employee_voucher
				INTO @voucherNo, @out_date, @duration

				SET @count = @count + 1

				END

			SET @content_detail += '<tr><td colspan="3"><b>Total Voucher '+CAST(@count AS VARCHAR(50))+'</b></td></tr></table>';

			CLOSE C_employee_voucher
			DEALLOCATE C_employee_voucher


			SET @subject = 'Voucher Out Reminder'
			SET @content = '
						<table border="0">
						<tr>
						<td>Dear '+@employee_name+',</td>
						</tr>

						<tr>
						<td>You got this notification letter because there is a voucher that has not been returned.<br><br></td>
						</tr>
						<tr>
						<td>' + @content_detail + '</td>
						</tr>
						</table>
						<br>
						<a href="http://10.246.142.20:54/"><b>Accounting Storage System</b></a>
						<br>
						<br>
						<br>
						<br>
						<br> 
						For more optimal view, please use Mozilla Firefox browser or Google Chrome'

						--DEV MODE
					SET @mail_to = 'zain.pradana@ykk.com'

					EXEC msdb.dbo.sp_send_dbmail
					@profile_name = 'YHA SMTP',
					@recipients = @mail_to,
					@copy_recipients='zain.pradana@ykk.com',
					@subject = @subject,
					@body = @content,
					@body_format = 'HTML'


		FETCH NEXT FROM C_employee_email
		INTO @employee_name, @mail_to, @user

		END



END

CLOSE C_employee_email
DEALLOCATE C_employee_email




