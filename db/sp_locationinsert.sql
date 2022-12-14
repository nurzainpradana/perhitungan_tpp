USE [ACC]
GO
/****** Object:  StoredProcedure [dbo].[sp_locationinsert]    Script Date: 8/31/2022 4:27:36 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
--exec [sp_insertLocation] 'ZIP1', '1', '2','AZ'
ALTER PROCEDURE [dbo].[sp_locationinsert]
	@factory varchar(50),
	@location varchar(50),
	@column varchar(3),
	@row varchar(3),
	@box varchar(3),
	@bantex varchar(4),
	@user varchar(50)

AS
BEGIN
	DECLARE @result varchar(50)

	SET NOCOUNT ON;

	-- Check Location Exists
	IF NOT EXISTS (SELECT * FROM storage_location SL WHERE SL.factory = @factory AND SL.location = @location AND SL.columns = @column AND SL.row = @row AND SL.box = @box AND SL.bantex = @bantex)
	BEGIN

		-- Insert Location
		INSERT INTO storage_location (factory, location, columns, row, box, bantex, location_name, status, created_by, created_date) 
		VALUES ( @factory, @location, @column, @row, @box, @bantex, CONCAT(@factory, '-', @location, '-', @column, '-', @row, '-', @box, '-',@bantex), 1, @user, CURRENT_TIMESTAMP);

		IF @@ROWCOUNT > 0
		BEGIN
		SET @result = 'success'
		END
		ELSE
		BEGIN
		SET @result = 'failed'
		END
	END
	ELSE
	BEGIN
		SET @result = 'exists'
	END
	
	SELECT @result as Result
END
