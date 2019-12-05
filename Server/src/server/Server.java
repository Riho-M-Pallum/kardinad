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
public class Server {
    static String address = "jdbc:mysql://localhost:3306/kardinad";
    static String username ="root";
    static String password = "";
    
    public static LinkedList<User> users = new LinkedList();
    /**
     * @param args the command line arguments
     */
    
    public static void main(String[] args) {
        try{
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection con = DriverManager.getConnection(address, username, password);  //connect to database
            Statement stmt = con.createStatement();                                     //connectionstatement
            ResultSet rs= stmt.executeQuery("select * from users");                     //rs get query
            while(rs.next()){                                                           //saves every entry into a linked list  
                User user1 = new User(rs.getString(1), rs.getString(2), rs.getString(3), rs.getString(4), rs.getString(5), rs.getString(6), rs.getString(7), rs.getString(8), rs.getString(9));
                users.add(user1);
            }
            print (users);
            con.close();    //close connection 
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(Server.class.getName()).log(Level.SEVERE, null, ex);   //catch 1
        } catch (SQLException ex) {
            Logger.getLogger(Server.class.getName()).log(Level.SEVERE, null, ex);   //catch 2
        }
        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                new edit_users().setVisible(true);
            }
        });    
    }
    
    public static void print(LinkedList<User> users){
        for (User u: users){
            System.out.println(u.Username);
        }
    }
    
}
