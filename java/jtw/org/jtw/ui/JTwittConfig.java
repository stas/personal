/*
 * Created on Jun 1, 2007
 */

package org.jtw.ui;

import java.io.IOException;
import java.util.Properties;

import msc.PropsToolkit;

/**
 * This class will load the twitter settings from the config file
 * independently from the client. Each interface simply needs to
 * initialize new JTwittConfig object, and call loadConfig() method.
 * 
 * If the initialization fails the loadConfig will return false, in
 * which case user can call createNewConfig() to generate new
 * configuration data.
 * 
 * @author Lukasz Grzegorz Maciak
 *
 */
public class JTwittConfig
{
	public static final String CONFIG_FILE_NAME = ".jtwitt";
	
	private Properties props;
	
	
	public JTwittConfig()
	{
		props = new Properties();
	}
	
	public boolean loadConfig()
	{
		try
		{
			props = PropsToolkit.readFromHomeDir(CONFIG_FILE_NAME);
		}
		catch (IOException e)
		{
			return false;
		}
		
		return (props != null);
	}
	
	public String getUsername()
	{
		return (String)props.get("username");
	}
	
	public String getPassword()
	{
		return (String)props.get("password");
	}
	
	public void setUsername(String username)
	{
		props.put("username", username);
	}
	
	public void setPassword(String password)
	{
		props.put("password", password);
	}
	
	public boolean createNewConfig(String username, String password)
	{
		setUsername(username);
		setPassword(password);
		
		try
		{
			PropsToolkit.writeIntoHomeDir(CONFIG_FILE_NAME, props);
		}
		catch (IOException e)
		{
			return false;
		}
		
		return true;
	}
	
	public boolean createNewConfig()
	{
		return createNewConfig(getUsername(), getPassword());
	}

}
