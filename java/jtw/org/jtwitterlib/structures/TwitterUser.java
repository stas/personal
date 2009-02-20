/*
 * Created on Apr 27, 2007
 */

package org.jtwitterlib.structures;

/**
 * TwitterUser Class holds information about a given Twitter user
 * 
 * @author Lukasz Grzegorz Maciak
 *
 */
public class TwitterUser
{
	//	 Twitter User Nodes (each corresponds to a XML node with the same name)
	public static final String ID = "id";
	public static final String NAME = "name";
	public static final String SCREEN_NAME = "screen_name";
	public static final String LOCATION = "location";
	public static final String DESCRIPTION = "description";
	public static final String PROFILE_IMAGE_URL = "profileImageURL";
	public static final String URL = "url";
	public static final String IS_PROTECTED = "isProtected";
	
	private int id;
	private String name;
	private String screenName;
	private String location;
	private String description;
	private String profileImageURL;
	private String url;
	private boolean isProtected;
	
	
	public TwitterUser(int id, String name, String screenName, String location, String description, String profileImageURL, String url, boolean isProtected)
	{
		super();
		this.id = id;
		this.name = name;
		this.screenName = screenName;
		this.location = location;
		this.description = description;
		this.profileImageURL = profileImageURL;
		this.url = url;
		this.isProtected = isProtected;
	}
	
	public TwitterUser()
	{
		
	}
	
	/**
	 * @return the description
	 */
	public String getDescription()
	{
		return description;
	}
	/**
	 * @param description the description to set
	 */
	public void setDescription(String description)
	{
		this.description = description;
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
	 * @return the isProtected
	 */
	public boolean isProtected()
	{
		return isProtected;
	}
	/**
	 * @param isProtected the isProtected to set
	 */
	public void setProtected(boolean isProtected)
	{
		this.isProtected = isProtected;
	}
	/**
	 * @return the location
	 */
	public String getLocation()
	{
		return location;
	}
	/**
	 * @param location the location to set
	 */
	public void setLocation(String location)
	{
		this.location = location;
	}
	/**
	 * @return the name
	 */
	public String getName()
	{
		return name;
	}
	/**
	 * @param name the name to set
	 */
	public void setName(String name)
	{
		this.name = name;
	}
	/**
	 * @return the profileImageURL
	 */
	public String getProfileImageURL()
	{
		return profileImageURL;
	}
	/**
	 * @param profileImageURL the profileImageURL to set
	 */
	public void setProfileImageURL(String profileImageURL)
	{
		this.profileImageURL = profileImageURL;
	}
	/**
	 * @return the screenName
	 */
	public String getScreenName()
	{
		return screenName;
	}
	/**
	 * @param screenName the screenName to set
	 */
	public void setScreenName(String screenName)
	{
		this.screenName = screenName;
	}
	/**
	 * @return the url
	 */
	public String getUrl()
	{
		return url;
	}
	/**
	 * @param url the url to set
	 */
	public void setUrl(String url)
	{
		this.url = url;
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
		final TwitterUser other = (TwitterUser) obj;
		if (id != other.id)
			return false;
		return true;
	}
	
	
	public String toString()
	{
		return 	this.getName() + " (" + this.getScreenName() + ")";
				
	}
	
	
}
