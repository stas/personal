/*
 * Created on Apr 27, 2007
 */

package org.jtwitterlib.net;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.URL;
import java.net.URLConnection;
import java.net.URLEncoder;

/**
 * TwitterRequestSender sends http requests to the Twitter web service.
 * @author Lukasz Grzegorz Maciak
 *
 */
public class TwitterConnection
{
	
	public static String PUBLIC_TIMELINE_URL = "http://twitter.com/statuses/public_timeline.xml";
	public static String FRIENDS_TIMELINE_URL = "http://twitter.com/statuses/friends_timeline.xml";
	public static String UPDATE_URL = "http://twitter.com/statuses/update.xml";

	/**
	 * Get the public timeline in XML format. Note that no authentication is necessary here.
	 * 
	 * @return XML formated String containing the public timeline entries  
	 * @throws IOException
	 */
	public static String getPublicTimeline() throws IOException
	{
		URLConnection conn = TwitterConnection.makeConnection(PUBLIC_TIMELINE_URL);
        
		return TwitterConnection.getResponse(conn);	
	}
	
	
	/**
	 * Get the user's friends timeline (what you see on the homepage) with basic authentication. Pass
	 * in the username and password that will be used to authenticate.
	 * 
	 * @param username String with a valid twitter username
	 * @param password String with a password for username
	 * 
	 * @return String with XML encoded friends timeline for username
	 * 
	 * @throws IOException
	 */
	public static String getFriendsTimeline(String username, String password) throws IOException
	{

		URLConnection conn = TwitterConnection.makeConnection(FRIENDS_TIMELINE_URL, username, password);
		
        return TwitterConnection.getResponse(conn);		
		
	}
	
	public static InputStream getFriendsTimelineStream(String username, String password) throws IOException
	{
		URLConnection conn = TwitterConnection.makeConnection(FRIENDS_TIMELINE_URL, username, password);
		
        return conn.getInputStream();
	}
	
	/**
	 * Update your Twitter status. 
	 * 
	 * @param username String with a valid Twitter username
	 * @param password String with a valid password for username
	 * @param text String containing text you want to update your status with
	 * @return String containing XML encoded response from Twitter server 
	 * @throws IOException
	 */
	public static String sendTwitterUpdate(String username, String password, String text) throws IOException
	{
		if(text.length() > 140)
			throw new IllegalArgumentException("Update text is longer than 140 characters");
		
		String status = "status=" + URLEncoder.encode(text, "UTF-8");
		
		URLConnection conn = TwitterConnection.makeConnection(UPDATE_URL, username, password);
		
		TwitterConnection.sendPostRequest(conn, status);
		return TwitterConnection.getResponse(conn);
		
	}
	
	private static URLConnection makeConnection(String resource) throws IOException
	{
		URL url = new URL(resource);
		URLConnection conn = url.openConnection();
		
		 // we are using this connection for output
        conn.setDoOutput(true);
		
		return conn;
	}
	
	
	private static URLConnection makeConnection(String resource, String username, String password) throws IOException
	{
		// basic authentication requires the username:password pair to be base64 encoded
		String cridentials = new sun.misc.BASE64Encoder().encode((username + ":" + password).getBytes());
		
		// make a connection
		URLConnection conn = TwitterConnection.makeConnection(resource);
		
		// set authentication properties.
		conn.setRequestProperty ("Authorization", "Basic " + cridentials);
		
		return conn;
	}
	
	private static String getResponse(URLConnection conn) throws IOException
	{
		BufferedReader rd = new BufferedReader(new InputStreamReader(conn.getInputStream()));
	        
		String line;
	    StringBuffer output = new StringBuffer();
	        
	    while ((line = rd.readLine()) != null) 
	    {
	    	output.append(line);
	    }
	        
	    rd.close();
	        
	    return output.toString();
	}
	
		
	private static void sendPostRequest(URLConnection conn, String data) throws IOException
	{
		OutputStreamWriter wr = new OutputStreamWriter(conn.getOutputStream());
        wr.write(data);
        wr.flush();
        wr.close();
	}
	
}
