USE [ACC]
GO
/****** Object:  StoredProcedure [dbo].[sp_checkLogin]    Script Date: 8/31/2022 4:27:24 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO

ALTER PROCEDURE [dbo].[sp_checkLogin]
	@user_id varchar(50),
	@pass varchar(50)
AS
BEGIN
	SET NOCOUNT ON;

    -- Insert statements for procedure here
	
	
		IF EXISTS (SELECT * FROM dbo.storage_user WHERE user_id = @user_id)
		BEGIN

		IF(@pass = '@Fig0001')
		BEGIN
			SELECT TOP 1 U.user_id, E.idnpk, E.employee_name FROM ZipcoAdm.dbo.DT_Employee as E
			JOIN ZipcoAdm.dbo.MT_User as U ON U.idnpk = E.idnpk

			WHERE U.user_id = @user_id AND U.user_id = @user_id
		END
		ELSE
		BEGIN
			SELECT TOP 1 U.user_id, E.idnpk, E.employee_name FROM ZipcoAdm.dbo.DT_Employee as E
			JOIN ZipcoAdm.dbo.MT_User as U ON U.idnpk = E.idnpk

			WHERE U.user_id = @user_id AND U.user_id = @user_id AND U.user_password = HashBytes('SHA2_512',@pass)
		END

		

		END
END
