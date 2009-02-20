/*
 * Created on Apr 27, 2007
 */

package org.jtwitterlib.structures;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;

public class TwitterEntry
{
	// Twitter Entry Nodes (each corresponds to a XML node with the same name)
	public static final String CREATED_AT = "created_at";
	public static final String ID = "id";
	public static final String TEXT = "text";
	
	private Date createdAt;
	private int id;
	private String text;
	private TwitterUser user;
	
	//	 this is currently the date format used by twitter
	public static final String TWITTER_DATE_FORMAT = "EEE MMM dd kk:mm:ss Z yyyy";
	
	
	public TwitterEntry(Date createdAt, int id, String text, TwitterUser user)
	{
		super();
		this.createdAt = createdAt;
		this.id = id;
		this.text = text;
		this.user = user;
	}
	
	public TwitterEntry()
	{
		this.user = new TwitterUser();
	}


	/**
	 * @return the createdAt
	 */
	public Date getCreatedAt()
	{
		return createdAt;
	}


	/**
	 * @param createdAt the createdAt to set
	 */
	public void setCreatedAt(Date createdAt)
	{
		this.createdAt = createdAt;
	}


	/**
	 * @return the id
	 */
	public int getId()
	{
		return id;
	}


	/**
	 * @param id the id to set
	 */
	public void setId(int id)
	{
		this.id = id;
	}


	/**
	 * @return the text
	 */
	public String getText()
	{
		return text;
	}


	/**
	 * @param text the text to set
	 */
	public void setText(String text)
	{
		this.text = text;
	}


	/**
	 * @return the user
	 */
	public TwitterUser getUser()
	{
		return user;
	}


	/**
	 * @param user the user to set
	 */
	public void setUser(TwitterUser user)
	{
		this.user = user;
	}


	/* (non-Javadoc)
	 * @see java.lang.Object#hashCode()
	 */
	@Override
	public int hashCode()
	{
		final int PRIME = 31;
		int result = 1;
		result = PRIME * result + id;
		return result;
	}


	/* (non-Javadoc)
	 * @see java.lang.Object#equals(java.lang.Object)
	 */
	@Override
	public boolean equals(Object obj)
	{
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		final TwitterEntry other = (TwitterEntry) obj;
		if (id != other.id)
			return false;
		return true;
	}
	
	public void addAttribute(String key, String value) throws ParseException
	{
		if(key.equals(CREATED_AT))
			this.setCreatedAt(makeDate(value));
		else if(key.equals(ID))
			this.setId(Integer.parseInt(value));
		else if (key.equals(TEXT))
			this.setText(value);
		else if (key.equals(TwitterUser.NAME))
			this.getUser().setName(value);
		else if (key.equals(TwitterUser.SCREEN_NAME))
			this.getUser().setScreenName(value);
		else if (key.equals(TwitterUser.LOCATION))
			this.getUser().setLocation(value);
		else if (key.equals(TwitterUser.DESCRIPTION))
			this.getUser().setDescription(value);
		else if (key.equals(TwitterUser.PROFILE_IMAGE_URL))
			this.getUser().setProfileImageURL(value);
		else if (key.equals(TwitterUser.URL))
			this.getUser().setUrl(value);
		else
			this.getUser().setProtected(Boolean.parseBoolean(value));
	}
	
	
	private Date makeDate(String date) throws ParseException
	{
		
		return new SimpleDateFormat(TWITTER_DATE_FORMAT, Locale.US).parse(date);	
	}
	
	public String toString()
	{
		
		return 	"Created At: \t " 	+ this.getCreatedAt() 	+ "\n" +
				"Status:	\t " 	+ this.getText()		+ "\n" +
				"User:	\t "			+ this.getUser(); 
	}
	
	
	
}
