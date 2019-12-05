/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package server;
import java.sql.*;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.util.LinkedList;
/**
 *
 * @author Riho
 */
public class User {
    String Username;
    String Passwordhash;
    String User_ID;
    String Email;
    String Longitude;
    String Latitude;
    String Sunset;
    String Sunrise;
    String Arduino_IP;
    
    public User(String Username, String Passwordhash, String User_ID, String Email, String Longitude, String Latitude, String Sunrise, String Sunset, String Arduino_IP) {
        this.Username = Username;
        this.Passwordhash = Passwordhash;
        this.User_ID = User_ID;
        this.Email = Email;
        this.Longitude = Longitude;
        this.Latitude = Latitude;
        this.Sunset = Sunset;
        this.Sunrise = Sunrise;
        this.Arduino_IP = Arduino_IP;
    }
}
