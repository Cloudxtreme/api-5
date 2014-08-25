SELECT
	*
FROM
	messages_attachments
WHERE
	messages_attachments.ma_type = 'image' AND
	messages_attachments.m_id IN (
		SELECT
			m_id
		FROM
			messages_attachments
		INNER JOIN
			messages_content USING ( m_id )
		WHERE
			messages_content.m_type =  'outgoing'
			AND ma_type =  'image'
		GROUP BY m_id
		HAVING COUNT(ma_id) > 1
	)
	AND messages_attachments.ma_id !=
	(
		SELECT MAX( ma_id )
		FROM messages_attachments b
		WHERE b.m_id = m_id
	)